import React, { useState } from "react";
import axios from "axios";
import { Button, FormControl, InputLabel, Input } from "@mui/material";
import userAuthenticationConfig from "../../utils/userAuthenticationConfig";
import Notification from "../elemets/notification/Notification";

const CompaniesCreate = () => {

  const [name, setName] = useState("");

  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const handleSubmit = (event) => {
    event.preventDefault();
    flushCompanies();
  };

  const flushCompanies = () => {
    setLoading(true);

    axios.post("/api/companies", { name }, userAuthenticationConfig()).then((response) => {
      setNotification({ ...notification, visible: true, type: "success", message: "Company created!" });
      setName("");
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    }).finally(() => {
      setLoading(false);
    });
  };

  return (
    <>
      {notification.visible &&
        <Notification notification={notification} setNotification={setNotification} />
      }
      <form onSubmit={handleSubmit}>
        <div>
          <FormControl style={{ width: 500 }}>
            <InputLabel htmlFor="name">Company nane</InputLabel>
            <Input
              id="name"
              type="text"
              label="Company name"
              name="name"
              value={name}
              onChange={(e) => setName(e.target.value)}
              required
            />
          </FormControl>
        </div>
        <br />
        <Button variant="contained" type="submit">
          Create company
        </Button>
      </form>
    </>
  );

};

export default CompaniesCreate;