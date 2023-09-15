import { NavLink, useNavigate } from "react-router-dom";
import { Helmet } from "react-helmet-async";
import { Button } from "@mui/material";

const CabinetContainer = () => {

  return (
    <>
      <Helmet>
        <title>
          Cabinet
        </title>
      </Helmet>

      {/* TODO: Manager cabinet */}
      <Button
        to="/flights"
        component={NavLink}
      >
        Flights
      </Button>
    </>
  );
};

export default CabinetContainer;