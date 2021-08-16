export default {
    SET_CARD_INFO (state, card) {
        console.log(card.id);
        state.card.id = card?.id;
        state.card.card_id = card?.card_id;
        state.card.alias = card?.alias;
        state.card.added_at = card?.added_at;
    }
};
