import { useNavigate } from "react-router-dom";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import * as React from "react";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import DashboardIcon from "@mui/icons-material/Dashboard";
import ListItemText from "@mui/material/ListItemText";
import BarChartIcon from "@mui/icons-material/BarChart";
import LayersIcon from "@mui/icons-material/Layers";
import ListSubheader from "@mui/material/ListSubheader";
import AssignmentIcon from "@mui/icons-material/Assignment";
import { AirplaneTicket, FlightRounded, FlightTakeoffRounded } from "@mui/icons-material";
import AccountCircleIcon from "@mui/icons-material/AccountCircle";

const Toolbar = () => {
  const navigate = useNavigate();

  const goTo = (route) => {
    navigate(route);
  }
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

          <ListItemButton  onClick={() => goTo("/cabinet/ticket")}>
            <ListItemIcon>
              <AirplaneTicket/>
            </ListItemIcon>
            <ListItemText primary="Tickets" />
          </ListItemButton>

          <ListItemButton onClick={() => goTo("/flights")}>
            <ListItemIcon>
              <FlightTakeoffRounded />
            </ListItemIcon>
            <ListItemText primary="Active Flights" />
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

          <ListItemButton onClick={() => goTo("/cabinet/profile")}>
            <ListItemIcon>
              <AccountCircleIcon />
            </ListItemIcon>
            <ListItemText primary="Profile" />
          </ListItemButton>

        </React.Fragment>
      </List>
    </>
  );
};

export default Toolbar;