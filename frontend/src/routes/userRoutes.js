import React, { lazy } from "react";
import routes from "./routes";
import { NavLink } from "react-router-dom";
import { Button } from "@mui/material";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CooperationPage = lazy(() => import("../pages/cooperation/CooperationPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const BuyTicketsPage = lazy(() => import("../pages/buyTicket/BuyTicketsPage"));

const userRoutes = [
  {
    path: "/panel/goods",
    element: <GoodsPage />
  },
  {
    path: "/cabinet",
    element: <CabinetPage />
  },
  {
    path: "/flight/:flightId/buy",
    element: <BuyTicketsPage />
  },
  {
    path: "/cooperation",
    element: <CooperationPage />
  }
];

const userRoutesConcat = userRoutes.concat(routes);

export default userRoutesConcat;