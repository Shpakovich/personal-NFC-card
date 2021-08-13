import Auth from "@/api/auth";
import Card from "@/api/card";

export default (context, inject) => {
  const factories = {
    auth: Auth(context.$axios),
    card: Card(context.$axios),
  };

  // Inject $api
  inject("api", factories);
};
