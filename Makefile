export EVENTBRITE_OAUTH=
export APP_DEBUG=true
serve:
	@cd web && php -d variables_order=EGPCS -S localhost:3000
