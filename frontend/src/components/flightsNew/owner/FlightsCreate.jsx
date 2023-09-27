import React, { useState } from "react";
import axios from "axios";
import { Button } from "@mui/material";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import Notification from "../../elemets/notification/Notification";
import InputDataLoader from "../../elemets/input/InputDataLoader";

const FlightsCreate = () => {

  const [company, setCompany] = useState("");
  const [fromAirport, setFromAirport] = useState(null);

  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const handleSubmit = (event) => {
    event.preventDefault();
    flushFlights();
  };

  const flushFlights = () => {
    setLoading(true);

    const data = {
      company: company.id,
      airport: fromAirport.id
    };

    axios.post("/api/company-flights", data, userAuthenticationConfig(false)).then(response => {
      setNotification({ ...notification, visible: true, type: "success", message: "Company flight created!" });
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
          <InputDataLoader
            name="company"
            label="Company"
            url="/api/companies"
            searchWord="name"
            getOptionLabel={(item) => `${item.name}`}
            onChange={(e, v) => setCompany(v)}
          />
        </div>
        <br />
        <div>
          <InputDataLoader
            name="fromInput"
            label="Airport"
            url="/api/airports"
            searchWord="name"
            getOptionLabel={(item) => `${item.name} (${item.city}, ${item.country})`}
            onChange={(e, v) => setFromAirport(v)}
          />
        </div>
        <br />
        <Button variant="contained" type="submit">
          Create flight
        </Button>
      </form>
    </>
  );

};

export default FlightsCreate;