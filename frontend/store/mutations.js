export default {
  setUserInfo (state, regInfo) {
    state.user.email = regInfo.email;
    state.user.password = regInfo.password;
  },
};
