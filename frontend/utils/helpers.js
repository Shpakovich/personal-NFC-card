export const isServer = process.server;
export const isBrowser = !isServer;

export function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
};

export const universalStorage = {
    getItem (itemKey) {
        if (isBrowser) {
            return localStorage.getItem( itemKey );
        }
    },

    setItem (itemKey, itemValue) {
        if (isBrowser) {
            try {
                localStorage.setItem( itemKey, itemValue );
            } catch (e) {
                console.log(e);
            }
        }
    },

    hasItem (itemKey) {
        return !!this.getItem( itemKey );
    },

    removeItem (itemKey) {
        if (isBrowser) {
            localStorage.removeItem( itemKey );
        }

        return true;
    }
};
