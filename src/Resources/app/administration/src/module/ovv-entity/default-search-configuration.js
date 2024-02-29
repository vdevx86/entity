const searchRankingPoint = Object.freeze({
    HIGH_SEARCH_RANKING: 500,
    LOW_SEARCH_RANKING: 80,
    MIDDLE_SEARCH_RANKING: 250,
});

const defaultSearchConfiguration = {
    _searchable: true,

    name: {
        _searchable: true,
        _score: searchRankingPoint.HIGH_SEARCH_RANKING,
    },

    description: {
        _searchable: true,
        _score: searchRankingPoint.MIDDLE_SEARCH_RANKING,
    },
};

export default defaultSearchConfiguration;
