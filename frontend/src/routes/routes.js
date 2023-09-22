import { lazy } from "react";
import RegistrationPage from "../pages/registration/RegistrationPage";

const HomePage = lazy(() => import("../pages/home/HomePage"));
const LoginPage = lazy(() => import("../pages/login/LoginPage"));
const CreateFlightsPage = lazy(() => import("../pages/flights/FlightsPage"));
const ResetPasswordPage = lazy(() => import("../pages/login/ResetPasswordPage"));

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
  {
    path: "/reset-password",
    element: <ResetPasswordPage />
  },
  {
    path: "/flights",
    element: <CreateFlightsPage />
  }
];

export default routes;