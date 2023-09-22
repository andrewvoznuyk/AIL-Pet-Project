import React, { useContext } from "react";
import Can from "../../components/elemets/can/Can";
import { default as ClientCooperationContainer } from "../../components/cooperation/client/CooperationContainer";
import { default as AdminCooperationContainer } from "../../components/cooperation/admin/CooperationContainer";
import { AppContext } from "../../App";
import { flights } from "../../rbac-consts";
import CreateManagerForm from "../../components/cooperation/owner/CreateManagerForm";

const CooperationPage = () => {
  const { user } = useContext(AppContext);

  return (
    <>
      <Can
        role={user.roles}
        perform={flights.ADMIN}
        yes={() => <AdminCooperationContainer />}
      />
      <Can
        role={user.roles}
        perform={flights.USER}
        yes={() => <ClientCooperationContainer />}
      />
      <Can
        role={user.roles}
        perform={flights.OWNER}
        yes={() => <CreateManagerForm />}
      />
    </>
  );
};

export default CooperationPage;