/**
 * @return {Promise<{token: string}>}
 * @param axios
 */
export default axios => ({
  registrationUser(data) {
    return axios.post('/auth/request', data);
  },

  confirmEmail(token) {
    return axios.post('/auth/confirm', {token});
  },

  resetPassword(email) {
    return axios.post('/auth/reset/request', {email});
  },

  confirmNewPassword(data) {
    return axios.post('auth/reset/confirm', data);
  }
})
