
export default axios => ({
  registrationCard (data) {
    return axios.post('/card/register', data);
  },
  getUserCardsInfo (data) {
    return axios.get('/user/cards');

    // TODO  если вернулись идём в поиск профиля если профиля нет то выводим фразу про проифль и ведём на его создание
  }
});
