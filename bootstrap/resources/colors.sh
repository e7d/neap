#!/bin/sh

text_black='\033[0;30m' # Black - Regular
text_red='\033[0;31m' # Red
text_green='\033[0;32m' # Green
text_blue='\033[0;34m' # Blue
text_yellow='\033[0;33m' # Yellow
text_purple='\033[0;35m' # Purple
text_cyan='\033[0;36m' # Cyan
text_white='\033[0;37m' # White
text_bold_black='\033[1;30m' # Black - Bold
text_bold_red='\033[1;31m' # Red
text_bold_green='\033[1;32m' # Green
text_bold_yellow='\033[1;33m' # Yellow
text_bold_blue='\033[1;34m' # Blue
text_bold_purple='\033[1;35m' # Purple
text_bold_cyan='\033[1;36m' # Cyan
text_bold_white='\033[1;37m' # White
text_underline_black='\033[4;30m' # Black - Underline
text_underline_red='\033[4;31m' # Red
text_underline_green='\033[4;32m' # Green
text_underline_yellow='\033[4;33m' # Yellow
text_underline_blue='\033[4;34m' # Blue
text_underline_purple='\033[4;35m' # Purple
text_underline_cyan='\033[4;36m' # Cyan
text_underline_white='\033[4;37m' # White
text_intense_black='\033[0;90m' # Black - High Intensity
text_intense_red='\033[0;91m' # Red
text_intense_green='\033[0;92m' # Green
text_intense_yellow='\033[0;93m' # Yellow
text_intense_blue='\033[0;94m' # Blue
text_intense_purple='\033[0;95m' # Purple
text_intense_cyan='\033[0;96m' # Cyan
text_intense_white='\033[0;97m' # White
text_bold_intense_black='\033[1;90m' # Black - Bold High Intensity
text_bold_intense_red='\033[1;91m' # Red
text_bold_intense_green='\033[1;92m' # Green
text_bold_intense_yellow='\033[1;93m' # Yellow
text_bold_intense_blue='\033[1;94m' # Blue
text_bold_intense_purple='\033[1;95m' # Purple
text_bold_intense_cyan='\033[1;96m' # Cyan
text_bold_intense_white='\033[1;97m' # White
background_black='\033[40m'   # Black - Background
background_red='\033[41m'   # Red
background_green='\033[42m'   # Green
background_yellow='\033[43m'   # Yellow
background_blue='\033[44m'   # Blue
background_purple='\033[45m'   # Purple
background_cyan='\033[46m'   # Cyan
background_white='\033[47m'   # White
intense_background_black='\033[0;100m'   # Black - Intense Background
intense_background_red='\033[0;101m'   # Red
intense_background_green='\033[0;102m'   # Green
intense_background_yellow='\033[0;103m'   # Yellow
intense_background_blue='\033[0;104m'   # Blue
intense_background_purple='\033[0;105m'   # Purple
intense_background_cyan='\033[0;106m'   # Cyan

intense_background_white='\033[0;107m'   # White
text_reset='\033[0m'    # Text Reset

# Standard echo
echo_black () {
    echo "${text_black}$@${text_reset}"
}
echo_red () {
    echo "${text_red}$@${text_reset}"
}
echo_green () {
    echo "${text_green}$@${text_reset}"
}
echo_yellow () {
    echo "${text_yellow}$@${text_reset}"
}
echo_blue () {
    echo "${text_blue}$@${text_reset}"
}
echo_purple () {
    echo "${text_purple}$@${text_reset}"
}
echo_cyan () {
    echo "${text_cyan}$@${text_reset}"
}
echo_white () {
    echo "${text_white}$@${text_reset}"
}

# Bold echo
echo_bold_black () {
    echo "${text_bold_black}$@${text_reset}"
}
echo_bold_red () {
    echo "${text_bold_red}$@${text_reset}"
}
echo_bold_green () {
    echo "${text_bold_green}$@${text_reset}"
}
echo_bold_yellow () {
    echo "${text_bold_yellow}$@${text_reset}"
}
echo_bold_blue () {
    echo "${text_bold_blue}$@${text_reset}"
}
echo_bold_purple () {
    echo "${text_bold_purple}$@${text_reset}"
}
echo_bold_cyan () {
    echo "${text_bold_cyan}$@${text_reset}"
}
echo_bold_white () {
    echo "${text_bold_white}$@${text_reset}"
}

# Underline echo
echo_underline_black () {
    echo "${text_underline_black}$@${text_reset}"
}
echo_underline_red () {
    echo "${text_underline_red}$@${text_reset}"
}
echo_underline_green () {
    echo "${text_underline_green}$@${text_reset}"
}
echo_underline_yellow () {
    echo "${text_underline_yellow}$@${text_reset}"
}
echo_underline_blue () {
    echo "${text_underline_blue}$@${text_reset}"
}
echo_underline_purple () {
    echo "${text_underline_purple}$@${text_reset}"
}
echo_underline_cyan () {
    echo "${text_underline_cyan}$@${text_reset}"
}
echo_underline_white () {
    echo "${text_underline_white}$@${text_reset}"
}

# Intense echo
echo_intense_black () {
    echo "${text_intense_black}$@${text_reset}"
}
echo_intense_red () {
    echo "${text_intense_red}$@${text_reset}"
}
echo_intense_green () {
    echo "${text_intense_green}$@${text_reset}"
}
echo_intense_yellow () {
    echo "${text_intense_yellow}$@${text_reset}"
}
echo_intense_blue () {
    echo "${text_intense_blue}$@${text_reset}"
}
echo_intense_purple () {
    echo "${text_intense_purple}$@${text_reset}"
}
echo_intense_cyan () {
    echo "${text_intense_cyan}$@${text_reset}"
}
echo_intense_white () {
    echo "${text_intense_white}$@${text_reset}"
}

# Bold Intense echo
echo_bold_intense_black () {
    echo "${text_bold_intense_black}$@${text_reset}"
}
echo_bold_intense_red () {
    echo "${text_bold_intense_red}$@${text_reset}"
}
echo_bold_intense_green () {
    echo "${text_bold_intense_green}$@${text_reset}"
}
echo_bold_intense_yellow () {
    echo "${text_bold_intense_yellow}$@${text_reset}"
}
echo_bold_intense_blue () {
    echo "${text_bold_intense_blue}$@${text_reset}"
}
echo_bold_intense_purple () {
    echo "${text_bold_intense_purple}$@${text_reset}"
}
echo_bold_intense_cyan () {
    echo "${text_bold_intense_cyan}$@${text_reset}"
}
echo_bold_intense_white () {
    echo "${text_bold_intense_white}$@${text_reset}"
}

# Background echo
echo_background_black () {
    echo "${background_black}$@${text_reset}"
}
echo_background_red () {
    echo "${background_red}$@${text_reset}"
}
echo_background_green () {
    echo "${background_green}$@${text_reset}"
}
echo_background_yellow () {
    echo "${background_yellow}$@${text_reset}"
}
echo_background_blue () {
    echo "${background_blue}$@${text_reset}"
}
echo_background_purple () {
    echo "${background_purple}$@${text_reset}"
}
echo_background_cyan () {
    echo "${background_cyan}$@${text_reset}"
}
echo_background_white () {
    echo "${background_white}$@${text_reset}"
}

# Intense Background echo
echo_intense_background_black () {
    echo "${intense_background_black}$@${text_reset}"
}
echo_intense_background_red () {
    echo "${intense_background_red}$@${text_reset}"
}
echo_intense_background_green () {
    echo "${intense_background_green}$@${text_reset}"
}
echo_intense_background_yellow () {
    echo "${intense_background_yellow}$@${text_reset}"
}
echo_intense_background_blue () {
    echo "${intense_background_blue}$@${text_reset}"
}
echo_intense_background_purple () {
    echo "${intense_background_purple}$@${text_reset}"
}
echo_intense_background_cyan () {
    echo "${intense_background_cyan}$@${text_reset}"
}
echo_intense_background_white () {
    echo "${intense_background_white}$@${text_reset}"
}

# Status echo
echo_info () {
    echo "${text_cyan}Info:${text_reset} $@"
}
echo_success () {
    echo "${text_green}Success:${text_reset} $@"
}
echo_warning () {
    echo "${text_yellow}Warning:${text_reset} $@"
}
echo_alert () {
    echo "${text_red}Alert:${text_reset} $@"
}
echo_error () {
    echo "${text_red}Error:${text_reset} $@"
}

# Symbols echo
echo_i () {
    echo "${text_bold_cyan}i ${text_reset}$@"
}
echo_valid () {
    echo "${text_bold_green}✓ ${text_reset}$@"
}
echo_star () {
    echo "${text_bold_yellow}★ ${text_reset}$@"
}
echo_love () {
    echo "${text_bold_red}❤ ${text_reset}$@"
}
echo_cross () {
    echo "${text_bold_red}✕ ${text_reset}$@"
}
