main:
	ansible-playbook -i hosts.yml main.yml

cron:
	ansible-playbook -i hosts.yml cron.yml

authorize:
	ansible-playbook -i hosts.yml authorize.yml

authorize-deploy:
	ansible-playbook -i hosts.yml authorize-deploy.yml

docker-login:
	ansible-playbook -i hosts.yml docker-login.yml

renew-certs:
	ansible-playbook -i hosts.yml renew-certs.yml

ping:
	ansible all -m ping -i hosts.yml

generate-deploy-key:
	ssh-keygen -q -t rsa -N '' -f files/deploy_rsa
