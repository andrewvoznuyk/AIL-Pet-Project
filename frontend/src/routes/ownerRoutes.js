import React, { lazy } from "react";
import routes from "./routes";
import ReportsPage from "../pages/reports/ReportsPage";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const FlightsPage = lazy(() => import("../pages/flights/FlightsPage"));
const CreateFlightPage = lazy(() => import("../pages/flightsNew/FlightsNewPage"));
const AircraftsPage = lazy(() => import("../pages/aircrafts/AircraftsPage"));
const AircraftsNewPage = lazy(() => import("../pages/aircraftsNew/AircraftsNewPage"));
const AircraftsEditPage = lazy(() => import("../pages/aircraftsEdit/AircraftsEditPage"));
const CooperationPage = lazy(() => import("../pages/cooperation/CooperationPage"));
const CompanyPage = lazy(() => import("../pages/company/CompanyPage"));
const CreateCompanyPage = lazy(() => import("../pages/companiesNew/CompaniesNewPage"));

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
    path: "/cooperation",
    element: <CooperationPage />
  },
  {
    path: "/cabinet/companies",
    element: <CompanyPage />
  },
  {
    path: "/cabinet/companies/new",
    element: <CreateCompanyPage />
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
  {
    path: "/cabinet/aircrafts/edit/:flightId",
    element: <AircraftsEditPage />
  },
  {
    path: "/cabinet/reports",
    element: <ReportsPage />
  }
];

const ownerRoutesConcat = ownerRoutes.concat(routes);

export default ownerRoutesConcat;