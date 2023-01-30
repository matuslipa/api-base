#/usr/bin/bash
set +e

# Disable and mute xdebug
export XDEBUG_CONFIG="mode=off start_with_request=no discover_client_host=false log_level=0"

VENDOR_BIN=vendor/bin

################################################################################
# Print success                                                                #
################################################################################
print_success()
{
    echo -e "\e[32m$1\e[0m"
}

################################################################################
# Print warning                                                                #
################################################################################
print_info()
{
    echo -e "\e[33m$1\e[0m"
}

################################################################################
# Print error                                                                  #
################################################################################
print_error()
{
    echo -e "\e[31m$1\e[0m"
}

################################################################################
# Help                                                                         #
################################################################################
help()
{
    print_info "Run tests and check requirements for code standards and functionality."
    echo
    print_info "Syntax: ./$(basename $0) <command> [--fix|--diff-only|--no-cache|--help]"
    echo
    print_info "Commands:"
    print_info "all          Run all available tools."
    print_info "ecs          Only run easy-coding-standard."
    print_info
    print_info "Options:"
    print_info "fix          Run tests and fix available issues."
    print_info "no-cache     Run tests without results cache."
    print_info "help         Print help."
    echo
    print_info "Example usage: ./$(basename $0) all --fix --diff-only"
}

################################################################################
# Easy-coding-standard                                                         #
################################################################################
ecs()
{
    local BIN_PATH=$VENDOR_BIN/ecs

    if [[ ! -f $BIN_PATH ]]; then
        print_error "Easy-coding-standard executable not found in $BIN_PATH."
        return 1
    fi

    local FIX_OPTION=$([[ $1 = true ]] && echo '--fix' || echo '')
    local FILES=$([[ $2 = true ]] && echo $(git_diff 'config|routes|App|database|resources/lang') || echo '.')
    local CACHE_OPTION=$([[ $3 = true ]] && echo '--clear-cache' || echo '')

    if [[ -n "$FILES" ]]; then
        php -d memory-limit=-1 $BIN_PATH check $FILES $CACHE_OPTION $FIX_OPTION
        return $? || 1
    else
        print_info "Easy-coding-standard skipped. No diff files to check available."
        echo
    fi

    return 0
}

# set default params
FIX=false
DIFF_ONLY=false
NO_CACHE=false

# get command
COMMAND="$1"

PARAMS_COUNT="$#"
if [[ "$PARAMS_COUNT" -eq 0 ]]; then
    print_error "No parameters passed. Run script with --help parameter to print help."
    exit 1
fi

while [[ "$#" -gt 0 ]]; do
    case $1 in
        --fix) FIX=true;;
        --diff-only) DIFF_ONLY=true;;
        --no-cache) NO_CACHE=true;;
        --help) help; exit 0;;
        *) [[ "$(($PARAMS_COUNT-$#))" -ne 0 ]] && print_error "Unknown parameter passed: '$1'. Run script with --help parameter to print help." && exit 1;;
    esac
    shift
done

RESULT=0
SUCCESS_MESSAGE="Ok."
case $COMMAND in
    all)
        ecs $FIX $DIFF_ONLY $NO_CACHE || RESULT=1
        SUCCESS_MESSAGE="You nailed it! All tests have passed. Let's get this merged."
        ;;
    ecs)
        ecs $FIX $DIFF_ONLY $NO_CACHE || RESULT=1
        SUCCESS_MESSAGE="Your code looks beautiful!"
        ;;
    *) echo "Unknown command: '$COMMAND'. Run script with --help parameter to print help."; exit 1;;
esac

if [[ $RESULT -eq 0 ]]; then
    print_info "░░░░░░░█▐▓▓░████▄▄▄█▀▄▓▓▓▌█ Epic tests";print_info "░░░░░▄█▌▀▄▓▓▄▄▄▄▀▀▀▄▓▓▓▓▓▌█";print_info "░░░▄█▀▀▄▓█▓▓▓▓▓▓▓▓▓▓▓▓▀░▓▌█";print_info "░░█▀▄▓▓▓███▓▓▓███▓▓▓▄░░▄▓▐█▌ level is so high";print_info "░█▌▓▓▓▀▀▓▓▓▓███▓▓▓▓▓▓▓▄▀▓▓▐█";print_info "▐█▐██▐░▄▓▓▓▓▓▀▄░▀▓▓▓▓▓▓▓▓▓▌█▌";print_info "█▌███▓▓▓▓▓▓▓▓▐░░▄▓▓███▓▓▓▄▀▐█ much +code";print_info "█▐█▓▀░░▀▓▓▓▓▓▓▓▓▓██████▓▓▓▓▐█";print_info "▌▓▄▌▀░▀░▐▀█▄▓▓██████████▓▓▓▌█▌";print_info "▌▓▓▓▄▄▀▀▓▓▓▀▓▓▓▓▓▓▓▓█▓█▓█▓▓▌█▌ Wow.";print_info "█▐▓▓▓▓▓▓▄▄▄▓▓▓▓▓▓█▓█▓█▓█▓▓▓▐█"
    print_success "$SUCCESS_MESSAGE"
else
    print_error "Well.. It seems that your code is not ready yet!"
fi

