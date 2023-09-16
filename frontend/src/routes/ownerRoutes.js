import { lazy } from "react";
import routes from "./routes";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const CreateFlightPage = lazy(() => import("../pages/flightsNew/FlightsNewPage"));

const ownerRoutes = [
  {
    path: "/panel/goods",
    element: <GoodsPage />
  },
  {
    path: "/cabinet",
    element: <CabinetPage />
  },
  {
    path: "/flights/new",
    element: <CreateFlightPage />
  },
];

const ownerRoutesConcat = ownerRoutes.concat(routes);

export default ownerRoutesConcat;