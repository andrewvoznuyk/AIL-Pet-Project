import { NavLink, useNavigate } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { Button } from "@mui/material";

const AircraftsContainer = () => {

  return (
    <>
      <Helmet>
        <title>
          Aircrafts
        </title>
      </Helmet>

      <Button
        to="/cabinet/aircrafts/new"
        component={NavLink}
        variant="outlined"
      >
        Add aircraft
      </Button>
    </>
  );
};

export default AircraftsContainer;