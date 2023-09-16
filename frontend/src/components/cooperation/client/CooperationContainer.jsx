import {
  Breadcrumbs,
  Button,
  FormControl,
  Grid,
  InputLabel,
  Link,
  MenuItem,
  Select,
  TextField,
  Typography,
  TextareaAutosize
} from "@mui/material";
import React, { useEffect, useState } from "react";
import { Helmet } from "react-helmet-async";
import { NavLink } from "react-router-dom";
import Notification from "../../elemets/notification/Notification";
import axios from "axios";
import userAuthenticationConfig from "../../../utils/userAuthenticationConfig";
import { responseStatus } from "../../../utils/consts";

const CooperationContainer = () => {

  const [loading, setLoading] = useState(false);
  const [notification, setNotification] = useState({
    visible: false,
    type: "",
    message: ""
  });

  const [companyName, setCompanyName] = useState("");
  const [fullname, setFullname] = useState("");
  const [email, setEmail] = useState("");
  const [fromAirport, setFromAirport] = useState(null);
  const [toAirport, setToAirport] = useState(null);
  const [about, setAbout] = useState("");
  const [documents, setDocuments] = useState("");

  const [airportList, setAirportList] = useState([]);

  const handleSubmit = (event) => {
    event.preventDefault();
    sendApply();
  };

  const sendApply = () => {
    setLoading(true);

    axios.post("https://courselab.com/api/cooperation-forms", {
      companyName: companyName,
      fullname: fullname,
      email: email,
      about: about,
      documents: documents,
      fromAirport: fromAirport,
      toAirport: toAirport
    }, userAuthenticationConfig(false)).then(response => {
      setNotification({ ...notification, visible: true, type: "success", message: "Form has been sent!" });
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    }).finally(() => {
      setLoading(false);
    });
  };

  const fetchAirports = () => {
    axios.get("/api/airports", userAuthenticationConfig()).then(response => {
      if (response.status === responseStatus.HTTP_OK && response.data["hydra:member"]) {
        setAirportList(response.data["hydra:member"]);
      }
    }).catch(error => {
      setNotification({ ...notification, visible: true, type: "error", message: error.response.data.title });
    });
  };

  useEffect(() => {
    fetchAirports();
  }, []);

  const availableToAirports = airportList.filter(item => item["@id"] !== fromAirport);

  return (
    <>
      <Helmet>
        <title>
          Cooperation
        </title>
      </Helmet>

      <Breadcrumbs aria-label="breadcrumb">
        <Link component={NavLink} underline="hover" color="inherit" to="/">
          Home
        </Link>
        <Link component={NavLink} underline="hover" color="inherit" to="/panel/goods">
          Goods
        </Link>
        <Typography color="text.primary">Cooperation</Typography>
      </Breadcrumbs>
      <Typography variant="h4" component="h1" mt={1}>
        Cooperation
      </Typography>
      <Grid container>
        <form onSubmit={handleSubmit}>
          {notification.visible &&
            <Notification notification={notification} setNotification={setNotification} />
          }
          <div>
            <p>Company name: </p>
            <FormControl style={{ width: 500 }}>
              <TextField
                id="companyName"
                label="Company"
                value={companyName}
                onChange={(e) => {setCompanyName(e.target.value);}}
                required
              >
              </TextField>
            </FormControl>
          </div>
          <br />
          <div>
            <p>Owner fullname: </p>
            <FormControl style={{ width: 500 }}>
              <TextField
                id="fullname"
                label="Fullname"
                value={fullname}
                onChange={(e) => {setFullname(e.target.value);}}
                required
              >
              </TextField>
            </FormControl>
          </div>
          <br />
          <div>
            <p>Your email: </p>
            <FormControl style={{ width: 500 }}>
              <TextField
                id="email"
                label="Email"
                value={email}
                onChange={(e) => {setEmail(e.target.value);}}
                required
              >
              </TextField>
            </FormControl>
          </div>
          <br />
          <p>Main flight (from-to): </p>
          <div>
            <FormControl style={{ width: 500 }}>
              <InputLabel id="fromL">From</InputLabel>
              <Select
                labelId="fromL"
                id="from"
                label="From"
                required
              >
                {airportList && airportList.map((item, key) => (
                  <MenuItem
                    key={key} value={item.name} onClick={() => {
                    setFromAirport(item["@id"]);
                  }}
                  >{item.name} ({item.city}, {item.country})</MenuItem>
                ))}
              </Select>
            </FormControl>
          </div>
          <br />
          <div>
            <FormControl style={{ width: 500 }}>
              <InputLabel id="toL">To</InputLabel>
              <Select
                labelId="toL"
                id="to"
                label="To"
                required
              >
                {availableToAirports && availableToAirports.map((item, key) => (
                  <MenuItem
                    key={key} value={item.name} onClick={() => {
                    setToAirport(item["@id"]);
                  }}
                  >{item.name} ({item.city}, {item.country})</MenuItem>
                ))}
              </Select>
            </FormControl>
          </div>
          <br />
          <div>
            <p>Tell us about your company: </p>
            <FormControl style={{ width: 500 }}>
              <TextareaAutosize
                label="About"
                aria-label="about"
                minRows={3}
                placeholder="About ... "
                value={about}
                onChange={(e) => {setAbout(e.target.value);}}
              />
            </FormControl>
          </div>
          <div>
            <p>Download your license: </p>
            <FormControl style={{ width: 500 }}>
              <input
                type="file" name="documents"
                value={documents}
                onChange={(e) => {setDocuments(e.target.value);}}
              />
            </FormControl>
          </div>
          <Button variant="contained" type="submit">
            Apply
          </Button>
        </form>
      </Grid>
    </>
  );
};

export default CooperationContainer;