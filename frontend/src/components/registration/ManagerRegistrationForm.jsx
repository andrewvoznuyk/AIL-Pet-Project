import React, { useEffect, useState } from "react";
import axios from "axios";
import { Helmet } from "react-helmet-async";
import { Box, Button, Grid, Typography } from "@mui/material";
import Notification from "../elemets/notification/Notification";
import { responseStatus } from "../../utils/consts";
import UserAuthenticationConfig from "../../utils/userAuthenticationConfig";
import GlobalRegistrationItems from "./GlobalRegistrationItems";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import InputDataLoader from "../elemets/input/InputDataLoader";

const ManagerRegistrationForm = () => {
  const [company, setCompany] = useState("");
  const [companiesList, setCompaniesList] = useState([]);

  const [authData, setAuthData] = useState();
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const fetchCompanies = () => {
    axios.get("/api/user-company", userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data) {
        setCompaniesList(response.data);
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  };

  useEffect(() => {
    fetchCompanies();
  }, []);

  const registrationRequest = () => {

    if (!authData) {
      return;
    }

    setLoading(true);

    axios.post(`/api/users`, authData, UserAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_CREATED) {
        setNotification({ ...notification, visible: true, type: "success", message: "done" });
      }
    }).catch(error => {
      setError(error.response.data.detail);
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.detail });
    }).finally(() => setLoading(false));
  };

  useEffect(() => {
    registrationRequest();
  }, [authData]);

  const handleSubmit = (event) => {
    event.preventDefault();

    const data = {
      email: event.target.email.value,
      password: event.target.password.value,
      name: event.target.name.value,
      surname: event.target.surname.value,
      phoneNumber: event.target.phoneNumber.value,
      managerAtCompany: company["@id"]
    };

    setAuthData(data);
  };

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
      <Box
        sx={{
          marginTop: 8,
          display: "flex",
          flexDirection: "column",
          alignItems: "center"
        }}
      >
        <Grid container style={{ width: "600px" }}>
          <Grid item xs={11} lg={5} sx={{ margin: "auto" }}>
            <form className="auth-form" onSubmit={handleSubmit} style={{ width: "300px" }}>
              <Typography variant="h4" component="h1">
                Create account
              </Typography>

              <GlobalRegistrationItems />

              <InputDataLoader
                name="company"
                label="Company"
                url="/api/companies"
                getOptionLabel={(option) => option.name}
                onChange={(e, v) => setCompany(v)}
              />

              <Button
                variant="contained"
                type="submit"
                disabled={loading}
              >
                Sign Up
              </Button>
            </form>
          </Grid>
        </Grid>
      </Box>
    </>
  );
};

export default ManagerRegistrationForm;