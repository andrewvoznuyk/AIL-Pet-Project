import { lazy } from "react";
import RegistrationPage from "../pages/registration/RegistrationPage";

const HomePage = lazy(() => import("../pages/home/HomePage"));
const LoginPage = lazy(() => import("../pages/login/LoginPage"));

const routes = [
  {
    path: "/",
    element: <HomePage />
  },
  {
    path: "/login",
    element: <LoginPage />
  },
  {
    path: "/register",
    element: <RegistrationPage />
  },
];

export default routes;