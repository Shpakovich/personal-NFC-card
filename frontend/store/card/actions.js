import { getCookie } from '../../utils/helpers'

export default {
    async setCard ({ commit }, aliasWithMask) {
        let alias;
        if(aliasWithMask) {
            alias = aliasWithMask.replace("https://myid-card.ru/", "");
            alias = alias.replace(/[^\w\s!?]/g,'')
        }
        const data = {
            id: getCookie('hash'),
            alias
        };
        const res = this.$api.card.registrationCard(data)
            .then((res)=> {
                commit('SET_CARD_INFO', res.data);
            }
        ).catch((err) => err);

        return res;
    },

    setCardInfo ({ commit }, card) {
        commit('SET_CARD_INFO', card);
    }
};
