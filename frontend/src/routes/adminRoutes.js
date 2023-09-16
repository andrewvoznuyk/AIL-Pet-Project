import { lazy } from "react";
import routes from "./routes";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const CreateFlightPage = lazy(() => import("../pages/flightsNew/FlightsNewPage"));

const adminRoutes = [
  {
    path: "/panel/goods",
    element: <GoodsPage />
  },
  {
    path: "/cabinet",
    element: <CabinetPage />
  },
];

const adminRoutesConcat = adminRoutes.concat(routes);

export default adminRoutesConcat;