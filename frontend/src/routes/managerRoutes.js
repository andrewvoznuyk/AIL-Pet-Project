import { lazy } from "react";
import routes from "./routes";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const FlightsPage = lazy(() => import("../pages/flights/FlightsPage"));
const CreateFlightPage = lazy(() => import("../pages/flightsNew/FlightsNewPage"));

const managerRoutes = [
  {
    path: "/panel/goods",
    element: <GoodsPage />
  },
  {
    path: "/cabinet",
    element: <CabinetPage />
  },
  {
    path: "/flights",
    element: <FlightsPage />
  },
  {
    path: "/flights/new",
    element: <CreateFlightPage />
  },
];

const managerRoutesConcat = managerRoutes.concat(routes);

export default managerRoutesConcat;