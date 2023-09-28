import { useNavigate } from "react-router-dom";
import Divider from "@mui/material/Divider";
import List from "@mui/material/List";
import * as React from "react";
import ListItemButton from "@mui/material/ListItemButton";
import ListItemIcon from "@mui/material/ListItemIcon";
import DashboardIcon from "@mui/icons-material/Dashboard";
import ListItemText from "@mui/material/ListItemText";
import BarChartIcon from "@mui/icons-material/BarChart";
import ListSubheader from "@mui/material/ListSubheader";
import AssignmentIcon from "@mui/icons-material/Assignment";
import { FlightTakeoffRounded } from "@mui/icons-material";
import AccountCircleIcon from "@mui/icons-material/AccountCircle";

const Toolbar = () => {
  const navigate = useNavigate();

  const goTo = (route) => {
    navigate(route);
  };

  return (
    <>
      <List component="nav">

        <React.Fragment>

          {/*<ListItemButton>
            <ListItemIcon>
              <DashboardIcon />
            </ListItemIcon>
            <ListItemText primary="Dashboard" />
          </ListItemButton>*/}

          <ListItemButton onClick={() => goTo("/cabinet/flights")}>
            <ListItemIcon>
              <FlightTakeoffRounded />
            </ListItemIcon>
            <ListItemText primary="Flights" />
          </ListItemButton>

          <ListItemButton onClick={() => goTo("/cabinet/reports")}>
            <ListItemIcon>
              <BarChartIcon />
            </ListItemIcon>
            <ListItemText primary="Reports" />
          </ListItemButton>

        </React.Fragment>

        <Divider sx={{ my: 1 }} />


        <React.Fragment>
          <ListSubheader component="div" inset>
            Other
          </ListSubheader>

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