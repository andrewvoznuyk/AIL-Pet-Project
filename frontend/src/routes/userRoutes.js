import React, { lazy } from "react";
import routes from "./routes";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CooperationPage = lazy(() => import("../pages/cooperation/CooperationPage"));
const CabinetPage = lazy(() => import("../pages/cabinet/CabinetPage"));
const BuyTicketsPage = lazy(() => import("../pages/buyTicket/BuyTicketsPage"));
const TicketPage = lazy(() => import("../pages/cabinet/TicketPage"));

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
  },
  {
    path: "/cabinet/ticket",
    element: <TicketPage />
  },
];

const userRoutesConcat = userRoutes.concat(routes);

export default userRoutesConcat;