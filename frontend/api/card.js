
export default axios => ({
  registrationCard (data) {
    return axios.post('/card/register', data);
  }
});
