export default axios => ({
    getMetric (data) {
        return axios.post('/metric/view', data);
    }
});
