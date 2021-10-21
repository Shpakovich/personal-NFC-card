import { itemsFavoritesMock } from '../constant';

export default {
    SET_FAVORITES_USERS (state, data) {
        // state.favorites = data.items;
        state.favorites = itemsFavoritesMock;
    },
    SET_USER_IN_FAVORITES_STATUS (state, status) {
        state.isUserInFavorites = status;
    }
}
