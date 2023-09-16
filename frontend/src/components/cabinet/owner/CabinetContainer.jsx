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

      {/* TODO: Owner cabinet */}
      <div className="some-search-div"></div>
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