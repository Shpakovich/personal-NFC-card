import colors from 'vuetify/es5/util/colors'
let development = process.env.NODE_ENV !== 'production';

export const apiServerEndpoint = process.env.API_ENDPOINT_SERVER;

export default {
  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    titleTemplate: 'personal-NFC-card',
    title: 'personal-NFC-card',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/myID-favicon.ico' }
    ]
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    '~/assets/styles/normalize.css',
    '~/assets/styles/fonts.scss'
  ],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    { src: "@/plugins/api.js" }
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/vuetify
    '@nuxtjs/vuetify',
    '@nuxtjs/tailwindcss'
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    'cookie-universal-nuxt'
  ],
  auth: {
    rewriteRedirects: true, // работает только с cookie-universal-nuxt
    plugins: ['~/plugins/auth.js'], //почему то работает с обратным редиректом
    redirect: {
      login: '/profile/page',
      logout: '/authorization',
      home: '/'
    },
    strategies: {
      local: {
        token: {
          property: 'access_token',
          global: true
        },
        user: {
          property: 'items'
        },
        endpoints: {
          login: { url: '/auth/token', method: 'post' },
          logout: { url: '', method: '' },
          user: { url: '/profiles', method: 'get' }
        }
      }
    }
  },

  axios: {
    baseURL: 'http://api',
    browserBaseURL: development ? 'http://localhost:8081' : 'https://api.myid-card.ru/'
  },

  // Vuetify module configuration: https://go.nuxtjs.dev/config-vuetify
  vuetify: {
    customVariables: ['~/assets/styles/variables.scss'],
    theme: {
      dark: false,
      themes: {
        light: {
          primary: '#475DEB',
          secondary: '#FFA436',
          accent: '#8c9eff',
          error: '#b71c1c',
        },
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
