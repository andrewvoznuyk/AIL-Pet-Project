import { lazy } from "react";
import routes from "./routes";
import ReportsPage from "../pages/reports/ReportsPage";

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
    path: "/cabinet/flights",
    element: <FlightsPage />
  },
  {
    path: "/cabinet/flights/new",
    element: <CreateFlightPage />
  },
  {
    path: "/cabinet/reports",
    element: <ReportsPage />
  }
];

const managerRoutesConcat = managerRoutes.concat(routes);

export default managerRoutesConcat;