import { getCookie } from '../../utils/helpers'

export default {
    async setCard ({ commit }, nick) {
        const alias = nick.substr(nick.indexOf("myid-card/") + 10);
        const data = {
            id: getCookie('hash'),
            alias
        };
        const res = this.$api.card.registrationCard(data)
            .then((res)=> {
                commit('SET_CARD_INFO', res.data);
            }
        ).catch((e) => console.log('card/setCard error' + e));

        return res;
    },

    setCardInfo ({ commit }, card) {
        commit('SET_CARD_INFO', card);
    }
};
