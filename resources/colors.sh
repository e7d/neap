#!/bin/bash

export text_black='\033[0;30m'                  # Black - Regular
export text_red='\033[0;31m'                    # Red
export text_green='\033[0;32m'                  # Green
export text_blue='\033[0;34m'                   # Blue
export text_yellow='\033[0;33m'                 # Yellow
export text_purple='\033[0;35m'                 # Purple
export text_cyan='\033[0;36m'                   # Cyan
export text_white='\033[0;37m'                  # White
export text_bold_black='\033[1;30m'             # Black - Bold
export text_bold_red='\033[1;31m'               # Red
export text_bold_green='\033[1;32m'             # Green
export text_bold_yellow='\033[1;33m'            # Yellow
export text_bold_blue='\033[1;34m'              # Blue
export text_bold_purple='\033[1;35m'            # Purple
export text_bold_cyan='\033[1;36m'              # Cyan
export text_bold_white='\033[1;37m'             # White
export text_underline_black='\033[4;30m'        # Black - Underline
export text_underline_red='\033[4;31m'          # Red
export text_underline_green='\033[4;32m'        # Green
export text_underline_yellow='\033[4;33m'       # Yellow
export text_underline_blue='\033[4;34m'         # Blue
export text_underline_purple='\033[4;35m'       # Purple
export text_underline_cyan='\033[4;36m'         # Cyan
export text_underline_white='\033[4;37m'        # White
export text_intense_black='\033[0;90m'          # Black - High Intensity
export text_intense_red='\033[0;91m'            # Red
export text_intense_green='\033[0;92m'          # Green
export text_intense_yellow='\033[0;93m'         # Yellow
export text_intense_blue='\033[0;94m'           # Blue
export text_intense_purple='\033[0;95m'         # Purple
export text_intense_cyan='\033[0;96m'           # Cyan
export text_intense_white='\033[0;97m'          # White
export text_bold_intense_black='\033[1;90m'     # Black - Bold High Intensity
export text_bold_intense_red='\033[1;91m'       # Red
export text_bold_intense_green='\033[1;92m'     # Green
export text_bold_intense_yellow='\033[1;93m'    # Yellow
export text_bold_intense_blue='\033[1;94m'      # Blue
export text_bold_intense_purple='\033[1;95m'    # Purple
export text_bold_intense_cyan='\033[1;96m'      # Cyan
export text_bold_intense_white='\033[1;97m'     # White
export background_black='\033[40m'              # Black - Background
export background_red='\033[41m'                # Red
export background_green='\033[42m'              # Green
export background_yellow='\033[43m'             # Yellow
export background_blue='\033[44m'               # Blue
export background_purple='\033[45m'             # Purple
export background_cyan='\033[46m'               # Cyan
export background_white='\033[47m'              # White
export intense_background_black='\033[0;100m'   # Black - Intense Background
export intense_background_red='\033[0;101m'     # Red
export intense_background_green='\033[0;102m'   # Green
export intense_background_yellow='\033[0;103m'  # Yellow
export intense_background_blue='\033[0;104m'    # Blue
export intense_background_purple='\033[0;105m'  # Purple
export intense_background_cyan='\033[0;106m'    # Cyan
export intense_background_white='\033[0;107m'   # White
export text_reset='\033[0m'                     # Reset

function echox()
{
    echo -e "$@${text_reset}"
}

export -f echox
