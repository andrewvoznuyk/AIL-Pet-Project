import { goods, flights, toolbar } from "./rbac-consts";

const rules = {
  ROLE_ADMIN: {
    static: [
      goods.ADMIN,
      toolbar.ADMIN
    ],
    dynamic: {}
  },

  ROLE_USER: {
    static: [
      goods.USER,
      flights.USER,
      toolbar.USER
    ],
    dynamic: {}
  },

  ROLE_OWNER: {
    static: [
      flights.OWNER,
      toolbar.OWNER
    ],
    dynamic: {}
  },

  ROLE_MANAGER: {
    static: [
      flights.MANAGER,
      toolbar.MANAGER
    ],
    dynamic: {}
  }
};

export default rules;
