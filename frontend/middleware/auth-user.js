export default async function ({ app, redirect }) {
  // the following look directly for the cookie created by nuxtjs/auth
  // instead of using $auth.loggedIn
  const user = await app.$cookies.get('auth._token.local');
  if (!user) {
    redirect('/authorization');
  }
}
