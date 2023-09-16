import React, { lazy } from "react";
import routes from "./routes";
import { NavLink } from "react-router-dom";
import { Button } from "@mui/material";

const GoodsPage = lazy(() => import("../pages/goods/GoodsPage"));
const CooperationPage = lazy(() => import("../pages/cooperation/CooperationPage"));

const userRoutes = [
  {
    path: "/panel/goods",
    element: <GoodsPage />
  },
  {
    path: "/panel/goods/cooperation",
    element: <CooperationPage />
  },
];

const userRoutesConcat = userRoutes.concat(routes);

export default userRoutesConcat;