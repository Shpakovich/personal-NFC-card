import Auth from "@/api/auth";
import Card from "@/api/card";
import Profile from "@/api/profile";
import Fields from "@/api/fields";
import Show from "@/api/show";
import Metric from "@/api/metric";

export default (context, inject) => {
  const factories = {
    auth: Auth(context.$axios),
    card: Card(context.$axios),
    profile: Profile(context.$axios),
    fields: Fields(context.$axios),
    show: Show(context.$axios),
    metric: Metric(context.$axios)
  };

  // Inject $api
  inject("api", factories);
};
