import * as React from "react";
import AppBar from "@mui/material/AppBar";
import Box from "@mui/material/Box";
import Toolbar from "@mui/material/Toolbar";
import Typography from "@mui/material/Typography";
import IconButton from "@mui/material/IconButton";
import MenuIcon from "@mui/icons-material/Menu";
import AccountCircle from "@mui/icons-material/AccountCircle";
import Menu from "@mui/material/Menu";
import DropdownLogged from "./DropdownLogged";
import DropdownUnlogged from "./DropdownUnlogged";
import { Button, rgbToHex } from "@mui/material";
import eventBus from "../../../../utils/eventBus";
import { NavLink, useNavigate } from "react-router-dom";
import { useContext } from "react";
import { AppContext } from "../../../../App";
import { display, width } from "@mui/system";
import CooperationPage from "../../../../pages/cooperation/CooperationPage";

export default function MenuAppBar () {

  const navigate = useNavigate();
  const { authenticated } = useContext(AppContext);
  const [anchorEl, setAnchorEl] = React.useState(null);

  const handleMenu = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const goTo = (route) => {
    navigate(route);
    handleClose();
  };

  const handleClose = () => {
    setAnchorEl(null);
  };

  return (
    <Box sx={{ flexGrow: 1 }}>
      <AppBar position="static" style={{display:"flex",width:"100%" , justifyContent:"space-between", alignItems:"center", color:"black", backgroundColor: 'rgba(0, 0, 255, 0)' , opacity:100, boxShadow: 'none'}}>
        <Toolbar style={{width:'100%', maxWidth:"1200px"}}>
          <Typography variant="h6" component="div" sx={{ flexGrow: 1 }} style={{fontSize:"25px", fontWeight:900}}>
            <IconButton onClick={() => goTo("/")} sx={{color: "black"}}>
              AIL
              </IconButton>
          </Typography>
          {authenticated &&
            <Button
              to="/cooperation"
              component={NavLink}
            >
              Cooperation
            </Button>
          }
          {(
            <div>
              <IconButton
                size="large"
                aria-label="account of current user"
                aria-controls="menu-appbar"
                aria-haspopup="true"
                onClick={handleMenu}
                color="inherit"
              >
                <AccountCircle />
              </IconButton>
              <Menu
                id="menu-appbar"
                anchorEl={anchorEl}
                anchorOrigin={{
                  vertical: "top",
                  horizontal: "right"
                }}
                keepMounted
                transformOrigin={{
                  vertical: "top",
                  horizontal: "right"
                }}
                open={Boolean(anchorEl)}
                onClose={handleClose}
              >
                {authenticated &&
                  <DropdownLogged goTo={goTo} />
                }
                {!authenticated &&
                  <DropdownUnlogged goTo={goTo} />
                }
              </Menu>
            </div>
          )}
        </Toolbar>
      </AppBar>
    </Box>
  );
}