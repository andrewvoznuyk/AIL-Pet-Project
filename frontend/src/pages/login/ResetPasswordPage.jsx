import { Button } from "@mui/material";
import InputPassword from "../../components/elemets/input/InputPassword";
import React, { useContext, useEffect, useState } from "react";
import axios from "axios";
import { responseStatus } from "../../utils/consts";
import UserAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { AppContext } from "../../App";
import InputCustom from "../../components/elemets/input/InputCustom";
import Notification from "../../components/elemets/notification/Notification";
import loginRequest from "../../utils/loginRequest";
import { authentication } from "../../utils/authenticationRequest";
import { useNavigate } from "react-router-dom";

const ResetPasswordPage = () => {
  const [authData, setAuthData] = useState({
    email: "",
    password: ""
  });
  const [loading, setLoading] = useState(false);
  const { authenticated, setAuthenticated } = useContext(AppContext);
  const navigate = useNavigate();

  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const handleSubmit = async (event) => {
    event.preventDefault();

    const data = {
      email: event.target.email.value,
      password: event.target.password.value
    };

    setAuthData(data);
  };

  const resetPassword = () => {
    setLoading(true);

    axios.put(`/api/reset-password`, authData, UserAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        //login immediately after registration
        loginRequest(authData,
          () => {
            setAuthenticated(true);
          });
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.detail });
    }).finally(() => setLoading(false));
  };

  useEffect(() => {
    if (authData.email && authData.password) {
      resetPassword();
    }
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
      <h2>Enter new password</h2>

      <form onSubmit={handleSubmit}>
        <InputCustom
          id="email"
          type="email"
          label="E-mail"
          name="email"
          required
        />
        <InputPassword
          label="New Password"
          id="password"
          name="password"
          required
        />
        <Button type="submit" variant="contained" color="primary">
          Reset Password
        </Button>
      </form>
    </>
  );
};

export default ResetPasswordPage;