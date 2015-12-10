/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

#include "unrealircd.h"

DLLFUNC int m_onlyopersjoin_prejoin(aClient *sptr, aChannel *chptr, char *parv[]);

ModuleHeader MOD_HEADER(m_onlyopersjoin) = {
    "m_onlyopersjoin",    /* Name of module */
    "v0.0.1", /* Version */
    "Only Opers Join", /* Short description of module */
    "3.2-b8-1",
    NULL
    };

MOD_INIT(m_onlyopersjoin)
{
    HookAdd(modinfo->handle, HOOKTYPE_PRE_LOCAL_JOIN, 0, m_onlyopersjoin_prejoin);
    return MOD_SUCCESS;
}

MOD_LOAD(m_onlyopersjoin)
{
    return MOD_SUCCESS;
}

MOD_UNLOAD(m_onlyopersjoin)
{
    return MOD_SUCCESS;
}

int m_onlyopersjoin_prejoin(aClient *sptr, aChannel *chptr, char *parv[])
{
    if (chptr->users >= 1) return HOOK_CONTINUE;
    if (IsOper(sptr)) return HOOK_CONTINUE;
    if (IsULine(sptr)) return HOOK_CONTINUE;
    sendnotice(sptr, "Sorry %s, only Opers can create channels", sptr->name);
    return HOOK_DENY;
}
