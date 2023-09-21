import { Breadcrumbs, Button, Drawer, Grid, Link, Typography } from "@mui/material";
import React from "react";
import {Helmet} from "react-helmet-async";
import {NavLink} from "react-router-dom";
import InitTicketSearch from "../../elemets/input/inputGroup/InitTicketSearch";
import Toolbar from "@mui/material/Toolbar";
import IconButton from "@mui/material/IconButton";
import ChevronLeftIcon from "@mui/icons-material/ChevronLeft";
import Divider from "@mui/material/Divider";
import BuyTicketsContainer from "./BuyTicketsContainer";

const Sidebar = () => {

  const [open, setOpen] = React.useState(true);

  const toggleDrawer = () => {
    setOpen(!open);
  };

    return (
        <>
          <Drawer variant="permanent" open={open}>
            <Toolbar
              sx={{
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'flex-end',
                px: [1],
              }}
            >
              <IconButton onClick={toggleDrawer}>
                <ChevronLeftIcon />
              </IconButton>
            </Toolbar>
            <Divider />
            {/*TODO: Sidebar content (selected tickets) */}
          </Drawer>
        </>
    );
};

export default Sidebar;