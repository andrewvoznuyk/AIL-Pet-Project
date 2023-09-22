import { useNavigate } from "react-router-dom";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import * as React from "react";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import DashboardIcon from "@mui/icons-material/Dashboard";
import ListItemText from "@mui/material/ListItemText";
import ListSubheader from "@mui/material/ListSubheader";
import AssignmentIcon from "@mui/icons-material/Assignment";
import { Business, FlightRounded, FlightTakeoffRounded } from "@mui/icons-material";

const Toolbar = () => {
  const navigate = useNavigate();

  const goTo = (route) => {
    navigate(route);
  };
  return (
    <>
      <List component="nav">

        <React.Fragment>

          <ListItemButton>
            <ListItemIcon>
              <DashboardIcon />
            </ListItemIcon>
            <ListItemText primary="Dashboard" />
          </ListItemButton>

          <ListItemButton onClick={() => goTo("/cabinet/aircrafts")}>
            <ListItemIcon>
              <FlightRounded />
            </ListItemIcon>
            <ListItemText primary="Aircrafts" />
          </ListItemButton>

          <ListItemButton onClick={() => goTo("/cabinet/flights")}>
            <ListItemIcon>
              <FlightTakeoffRounded />
            </ListItemIcon>
            <ListItemText primary="Flights" />
          </ListItemButton>

          <ListItemButton onClick={() => goTo("/cabinet/companies")}>
            <ListItemIcon>
              <Business />
            </ListItemIcon>
            <ListItemText primary="Companies" />
          </ListItemButton>

        </React.Fragment>

        <Divider sx={{ my: 1 }} />

        <React.Fragment>
          <ListSubheader component="div" inset>
            Saved reports
          </ListSubheader>
          <ListItemButton>
            <ListItemIcon>
              <AssignmentIcon />
            </ListItemIcon>
            <ListItemText primary="Current month" />
          </ListItemButton>

          <ListItemButton>
            <ListItemIcon>
              <AssignmentIcon />
            </ListItemIcon>
            <ListItemText primary="Last quarter" />
          </ListItemButton>

        </React.Fragment>
      </List>
    </>
  );
};

export default Toolbar;