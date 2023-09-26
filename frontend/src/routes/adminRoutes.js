import React, { lazy } from "react";
import routes from "./routes";
import ReportsPage from "../pages/reports/ReportsPage";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const CooperationPage = lazy(() => import("../pages/cooperation/CooperationPage"));

const adminRoutes = [
  {
    path: "/cooperation",
    element: <CooperationPage />
  },
  {
    path: "/panel/goods",
    element: <GoodsPage />
  },
  {
    path: "/cabinet",
    element: <CabinetPage />
  },
  {
    path: "/cabinet/reports",
    element: <ReportsPage />
  },
];

const adminRoutesConcat = adminRoutes.concat(routes);

export default adminRoutesConcat;