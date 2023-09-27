import { Helmet } from "react-helmet-async";
import PlaneSelectForm from "../../planeSelect/PlaneSelectForm";
import * as React from "react";

const AircraftsNewContainer = () => {

  return (
    <>
      <Helmet>
        <title>
          Add Aircraft
        </title>
      </Helmet>

      <PlaneSelectForm />
    </>
  );
};

export default AircraftsNewContainer;