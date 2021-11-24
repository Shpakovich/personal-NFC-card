import { itemsFavoritesMock } from '../constant';

export default {
    SET_FAVORITES_USERS (state, data) {
        state.favorites = data.items;
        // state.favorites = itemsFavoritesMock;
    },
    SET_USER_IN_FAVORITES (state, id) {
        state.userInFavorites.status = true;
        state.userInFavorites.id = id;
    },
    RESET_USER_IN_FAVORITES (state) {
        state.userInFavorites.status = false;
        state.userInFavorites.id = '';
    }
}
