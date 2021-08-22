export default axios => ({
    getShowProfile (cardID) {
        return axios.get(`/show/${cardID}`);
    }
})
