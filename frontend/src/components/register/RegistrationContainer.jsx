import { useContext, useEffect, useState } from "react";
import { NavLink, useNavigate } from "react-router-dom";
import axios from "axios";
import { Helmet } from "react-helmet-async";
import { Breadcrumbs, Link, Typography } from "@mui/material";
import Notification from "../elemets/notification/Notification";
import { authentication } from "../../utils/authenticationRequest";
import { responseStatus } from "../../utils/consts";
import { AppContext } from "../../App";
import loginRequest from "../../utils/loginRequest";
import RegistrationForm from "./RegistrationForm";

const RegistrationContainer = () => {
  const navigate = useNavigate();

  const { setAuthenticated, authenticated } = useContext(AppContext);

  const [authData, setAuthData] = useState();
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const authenticationRequest = () => {
    if (!authData) {
      return;
    }

    setLoading(true);

    loginRequest(authData,
        () => {
          setAuthenticated(true);
        },
        (message) => {
          setError(message);
          setNotification({ ...notification, visible: true, type: "error", message: message });
        },
        () => {
          setLoading(false);
        });

 axios.post(`/api/register`, authData).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data.token) {
        localStorage.setItem("token", response.data.token);
        setAuthenticated(true);
      }
    }).catch(error => {
      setError(error.response.data.message);
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.message });
    }).finally(() => setLoading(false));
  };

  useEffect(() => {
    authenticationRequest();
  }, [authData]);

  useEffect(() => {
    authentication(navigate, authenticated);
  }, [authenticated]);

  return (
    <>
      {notification.visible &&
        <Notification
          notification={notification}
          setNotification={setNotification}
        />
      }
      <Helmet>
        <title>
          Create account
        </title>
      </Helmet>
      <RegistrationForm
        setAuthData={setAuthData}
        loading={loading}
      />
    </>
  );
};

export default RegistrationContainer;