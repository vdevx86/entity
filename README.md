# Entity plugin for Shopware 6

Create entities from the admin panel, group them by types, store twig templates in database and use them to render entities.

## Entities and their fields

### Entity

The main entity type named "Entity"

*Admin menu: "Content" > "Entity" > "Entities"*

- **Status:** Active or Inactive;
- **Sales Channel:** a Sales Channel under which this entity will be available;
- **Type:** ability to assign an entity to a group;
- **Name:** a name often used with entities;
- **Slug:** a shortname which makes loading of entities easier using twig functions;
- **Description:** describe an entity or store data to use it with rendering;
- **Media:** attach any amount of media you want;
- **Custom fields:** fill custom fields created with the default "Custom fields" functionality (create a set, assign it to the "Entities" type and attach custom fields to the set);

### Entity type

Use types to group entities

*Admin menu: "Content" > "Entity" > "Types"*

- **Status:** Active or Inactive;
- **Name:** a name of an entity type;
- **Slug:** a shortname which makes loading of entity types easier using twig functions;

### Entity template

Store twig templates and assign them to renderers to declare rendered entities look

*Admin menu: "Content" > "Entity" > "Templates"*

- **Name:** a name of an entity template;
- **Slug:** a shortname which makes loading of entity templates easier using twig functions;
- **Template:** a template body in the twig format;

### Entity renderer

Declare options of rendering for a group of entities

*Admin menu: "Content" > "Entity" > "Renderers"*

- **Status:** Active or Inactive;
- **Name:** a name of a renderer;
- **Slug:** a shortname which makes loading of entity renderer easier using twig functions;
- **Description:** describe what it does, where it could be seen on the storefront and other important information;
- **Template:** assign a template to a renderer;
- **Types**: limit entities loaded by these selected entity types;
- **Entities**: limit entities loaded by assigning them directly to a renderer;

## Rendering

The "Entity renderer" is a special abstract term and the way to set the options of rendering.
Use its unique ID along with the special shortcode prefix to trigger the rendering process on a specific storefront area.

There are two main ways of rendering:
- insert a special shortcode into any "renderable" area such as a CMS "Text" block or a product description; you should build this shortcode manually by using the unique "entity-renderer-" prefix + a unique renderer ID (for example, "entity-renderer-123");
- load data with the provided set of twig functions and use it to render content manually (for example, from inside a physical twig template);

Access data of entities from a twig template by using the **entities** variable.

## Twig functions

with examples

```twig
{# Load entities by ID(s) #}
{% set entities = entityById([4]) %}
{% set entities = entityById([1, 4, 6]) %}

{# Load entities by Slug(s) #}
{% set entities = entityBySlug(['testslug1', 'testslug4', 'anothertestslug6']) %}

{# Load entities by type ID(s) #}
{% set entities = entityByTypeId([1, 4, 6]) %}

{# Load type(s) by type ID(s) #}
{% set types = entityTypeById([2, 5]) %}

{# Load type(s) by type Slug(s) #}
{% set types = entityTypeBySlug(['testtypeslug1', 'anothertypeslug4']) %}

{# Load template(s) by template ID(s) #}
{% set templates = entityTemplateById([8, 10]) %}

{# Load template(s) by template Slug(s) #}
{% set templates = entityTemplateBySlug(['testtemplateslug8', 'anothertemplateslug10']) %}

{# Load entity renderer by ID and trigger entities rendering loaded by ID(s) #}
{{ entityRenderById(3, entityById([1, 4, 6]))|raw }}

{# Load entity renderer by Slug and trigger entities rendering loaded by Slug #}
{{ entityRenderBySlug('renderertestslug1', entityBySlug(['entitytestslug1']))|raw }}

```

## Usecase

Lets assume you have to create an atypical gallery for the home page.
Possible steps could be...

1) Go to: "Content" > "Entity" > "Types"

and create a type "Main Gallery".

2) Go to: "Content" > "Entity" > "Entities"

and create N (lets assume 4) entities of the type "Main Gallery".

Give names like "Main Gallery - Slide #(1-4)", assign Sales Channel and a cover image.
Also assign a slug "maingallery" to each entity.

3) Go to: "Content" > "Entity" > "Templates"

and create a twig template where you can render your entities

Give it a name "Main Gallery".

Example:

```twig
{% for entity in entities %}
    {% set media = entity.cover.media %}

{% endfor %}
```

4) Go to: "Content" > "Entity" > "Renderers"

and create a renderer, give it a name "Main Gallery".

Assign it the previously created twig template and add the entity type created during the first step.

5) Go to: "Content" > "Shopping Experiences"

Add a "Plain text" block from the "Text" block category, fill it with the "entity-renderer-N" shortcode and save (where N is an unique renderer ID)

It is also possible to render a renderer from the theme, for example:
```twig
{{ entityRenderBySlug('maingallery', entityByTypeId([1]))|raw }}
```

## Additional functionality

- the "Plain text" CMS block which allows to enter raw text/html

## Requirements

Shopware 6 v6.5.5.0 or higher

## License

[MIT](LICENCE.md)
