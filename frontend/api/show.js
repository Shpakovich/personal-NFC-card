export default axios => ({
    getShowProfile (cardID) {
        return axios.get(`/show/${cardID}`);
    },
    getFieldsToTypeShow (showInfo) {
        return axios.get(`/show/${showInfo.cardID}/type/${showInfo.typeID}`);
    }
})
