import React, { useContext, useEffect, useState } from "react";
import axios from "axios";
import UserAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { AppContext } from "../../App";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import { responseStatus } from "../../utils/consts";
import Notification from "../elemets/notification/Notification";
import { Button, Grid, Input, Link, Modal, TextField } from "@mui/material";
import ModalConfirmEmail from "../elemets/modalForConfirm/ModalConfirmEmail";
import generateRandomCode from "../../utils/generateRandomCode";
import { useNavigate } from "react-router-dom";

const UpdateProfileContainer = () => {
  const { authenticated, setAuthenticated } = useContext(AppContext);
  const navigate = useNavigate();
  const { user } = useContext(AppContext);

  const [name, setName] = useState("");
  const [surname, setSurname] = useState("");
  const [phoneNumber, setPhoneNumber] = useState("");
  const [email, setEmail] = useState("");
  const [newEmail, setNewEmail] = useState("");
  const [authData, setAuthData] = useState();
  const [code, setCode] = useState("");
  const [mileBonuses, setMileBonuses] = useState("");

  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [modalOpen, setModalOpen] = useState(false);
  const [isEmailConfirmed, setIsEmailConfirmed] = useState(false);
  const [modalEmailOpen, setModalEmailOpen] = useState(false);
  const [randomCode, setRandomCode] = useState(null);

  const getUserInfo = () => {
    axios.get("/api/username",
      userAuthenticationConfig()).then((response) => {
      setName(response.data.name);
      setSurname(response.data.surname);
      setPhoneNumber(response.data.phoneNumber);
      setEmail(response.data.email);
      setMileBonuses(response.data.mileBonuses);
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  };

  const handleSubmit = (event) => {
    event.preventDefault();

    const data = {
      email: email,
      name: name,
      surname: surname,
      phoneNumber: phoneNumber
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
    setModalEmailOpen(false);
  };

  const updateUser = () => {

    if (!authData) {
      return;
    }

    setLoading(true);

    if (!isEmailConfirmed) {
      setNotification({ ...notification, visible: true, type: "error", message: "Email is not confirmed" });
      setLoading(false);
      return;
    }

    axios.put("/api/update-user", authData, UserAuthenticationConfig()).then((response) => {
      setNotification({ ...notification, visible: true, type: "success", message: "Profile was updated! " });
      setModalEmailOpen(false);
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    }).finally(() => {
      setLoading(false);
      setModalOpen(false);
    });
  };

  const handleUpdateEmail = () => {
    setModalEmailOpen(true);
  };

  const handleGenerateCode = () => {
    const code = generateRandomCode();
    setRandomCode(code);

    setNotification({ ...notification, visible: true, type: "info", message: `Generated code: ${code}` });
  };

  const handleConfirmCode = (enteredCode) => {

    if (randomCode !== null && enteredCode !== randomCode.toString()) {
      setNotification({ ...notification, visible: true, type: "error", message: "Wrong code." });
      setModalEmailOpen(false);
    } else {
      const data = {
        email: newEmail,
        name: name,
        surname: surname,
        phoneNumber: phoneNumber
      };

      axios.put("/api/update-user", data, UserAuthenticationConfig()).then((response) => {
        setModalEmailOpen(false);
        setAuthenticated(false);
        navigate("/login");
      }).catch(error => {
        setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
      }).finally(() => {
        setModalOpen(false);
      });
    }
  };

  useEffect(() => {
    getUserInfo();
  }, []);

  return (
    <>
      {notification.visible &&
        <Notification notification={notification} setNotification={setNotification} />
      }
      <form className="auth-form" onSubmit={handleSubmit} style={{ width: "300px" }}>

        <h3>Your profile</h3>

        {user.roles.includes("ROLE_USER") &&
          <div>Your mile bonuses = {mileBonuses}</div>
        }

        <TextField
          label="Name: "
          variant="outlined"
          value={name}
          onChange={(e) => setName(e.target.value)}
          required
        />

        <TextField
          id="surname"
          type="text"
          label="Surname"
          name="surname"
          value={surname}
          onChange={(e) => setSurname(e.target.value)}
          required
        />

        <TextField
          id="email"
          type="email"
          label="E-mail"
          name="email"
          value={email}
          aria-readonly
        />

        <TextField
          id="phoneNumber"
          label="Phone Number"
          name="phoneNumber"
          value={phoneNumber}
          onChange={(e) => setPhoneNumber(e.target.value)}
          required
        />
        <Button
          variant="contained"
          type="submit"
          disabled={loading}
        >
          Save changes
        </Button>
        {/*<Grid item>
          <Link variant="body2" onClick={handleUpdateEmail}>
            {"Want to update your email?"}
          </Link>
        </Grid>*/}
      </form>

      <ModalConfirmEmail
        open={modalOpen}
        onClose={() => setModalOpen(false)}
        onConfirm={updateUser}
        onNotMyEmail={handleCloseModal}
      />

      <Modal open={modalEmailOpen} onClose={() => setModalEmailOpen(false)}>
        <div className="modal-container">
          <div className="modal-content">
            <h3>Confirm Phone number</h3>
            <TextField
              id="phoneNumber"
              label="Phone Number"
              name="phoneNumber"
              value={phoneNumber}
              disabled
            />
            <Button variant="contained" color="primary" onClick={handleGenerateCode}>
              Confirm
            </Button>
            <h3>Enter code</h3>
            <TextField
              id="code"
              label="Code"
              name="code"
              value={code}
              onChange={(e) => setCode(e.target.value)}
            />
            <br />
            <TextField
              id="newEmail"
              type="email"
              label="New email"
              name="newEmail"
              value={newEmail}
              onChange={(e) => setNewEmail(e.target.value)}
            />
            <Button variant="contained" color="primary" style={{ marginRight: 70 }} onClick={() => handleConfirmCode(code)}>
              Confirm and login
            </Button>
            <Button variant="contained" color="inherit" onClick={handleCloseModal}>
              Close
            </Button>
          </div>
        </div>
      </Modal>
    </>
  );

};

export default UpdateProfileContainer;