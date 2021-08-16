import Auth from "@/api/auth";
import Card from "@/api/card";
import Profile from "@/api/profile";

export default (context, inject) => {
  const factories = {
    auth: Auth(context.$axios),
    card: Card(context.$axios),
    profile: Profile(context.$axios),
  };

  // Inject $api
  inject("api", factories);
};
