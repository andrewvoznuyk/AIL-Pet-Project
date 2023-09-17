import React, { lazy } from "react";
import routes from "./routes";
import { NavLink } from "react-router-dom";
import { Button } from "@mui/material";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CooperationPage = lazy(() => import("../pages/cooperation/CooperationPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const CreateFlightPage = lazy(() => import("../pages/flightsNew/FlightsNewPage"));

const userRoutes = [
  {
    path: "/panel/goods/cooperation",
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
];

const userRoutesConcat = userRoutes.concat(routes);

export default userRoutesConcat;