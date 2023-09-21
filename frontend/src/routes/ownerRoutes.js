import { lazy } from "react";
import routes from "./routes";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const FlightsPage = lazy(() => import("../pages/flights/FlightsPage"));
const CreateFlightPage = lazy(() => import("../pages/flightsNew/FlightsNewPage"));
const AircraftsPage = lazy(() => import("../pages/aircrafts/AircraftsPage"));
const AircraftsNewPage = lazy(() => import("../pages/aircraftsNew/AircraftsNewPage"));

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
    path: "/cabinet/flights",
    element: <FlightsPage />
  },
  {
    path: "/cabinet/flights/new",
    element: <CreateFlightPage />
  },
  {
    path: "/cabinet/aircrafts",
    element: <AircraftsPage />
  },
  {
    path: "/cabinet/aircrafts/new",
    element: <AircraftsNewPage />
  },
];

const ownerRoutesConcat = ownerRoutes.concat(routes);

export default ownerRoutesConcat;