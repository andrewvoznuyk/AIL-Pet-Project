import { useContext } from "react";
import { AppContext } from "../../App";
import NotFoundPage from "../notFound/NotFoundPage";
import CabinetDefaultContainer from "../../components/elemets/cabinet/CabinetDefaultContainer";
import ToolbarRoleSwitch from "../../components/elemets/cabinet/toolbars/ToolbarRoleSwitch";
import { flights } from "../../rbac-consts";
import Can from "../../components/elemets/can/Can";
import TicketContainer from "../../components/ticket/TicketContainer";

const TicketPage = () => {

  return (
    <>
      <CabinetDefaultContainer
        Sidebar={<ToolbarRoleSwitch />}
        Content={<ContentRoleSwitch />}
      />
    </>
  );
};

const ContentRoleSwitch = () => {
  const { user } = useContext(AppContext);

  if (!user) {
    return <NotFoundPage />;
  }

  return (
    <Can
      role={user.roles}
      perform={flights.USER}
      yes={() => <TicketContainer />}
    />
  );
};

export default TicketPage;