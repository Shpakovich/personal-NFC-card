import Auth from "@/api/auth";

export default (context, inject) => {
  const factories = {
    auth: Auth(context.$axios)
  };

  // Inject $api
  inject("api", factories);
};
