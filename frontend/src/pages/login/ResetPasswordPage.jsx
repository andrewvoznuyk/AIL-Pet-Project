import { Button, Modal } from "@mui/material";
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
import ModalConfirmEmail from "../../components/elemets/modalForConfirm/ModalConfirmEmail";

const ResetPasswordPage = () => {
  const [authData, setAuthData] = useState("");
  const [loading, setLoading] = useState(false);
  const { authenticated, setAuthenticated } = useContext(AppContext);
  const navigate = useNavigate();

  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [modalOpen, setModalOpen] = useState(false);
  const [isEmailConfirmed, setIsEmailConfirmed] = useState(false); // Додайте змінну для відстеження статусу підтвердження пошти

  const handleSubmit = (event) => {
    event.preventDefault();

    const data = {
      email: event.target.email.value,
      password: event.target.password.value
    };

    setAuthData(data);

    axios.post("/api/confirm-email", data).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        setIsEmailConfirmed(true);
        setModalOpen(true);
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.detail });
    });

  };

  const handleCloseModal = () => {
    setModalOpen(false);
    setIsEmailConfirmed(false);
  };

  const resetPassword = () => {
    setLoading(true);

    if (!isEmailConfirmed) {
      setNotification({ ...notification, visible: true, type: "error", message: "Email is not confirmed" });
      setLoading(false);
      return;
    }

    axios.put(`/api/reset-password`, authData, UserAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK) {
        //login immediately after registration
        loginRequest(authData,
          () => {
            navigate("/login");
          });
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.detail });
    }).finally(() => {
      setLoading(false);
      setModalOpen(false);
    });
  };

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

      <ModalConfirmEmail
        open={modalOpen}
        onClose={() => setModalOpen(false)}
        onConfirm={resetPassword}
        onNotMyEmail={handleCloseModal}
      />
    </>
  );
};

export default ResetPasswordPage;