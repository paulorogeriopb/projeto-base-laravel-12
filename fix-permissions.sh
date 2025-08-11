#!/bin/bash
# fix-permissions.sh

echo "Ajustando permissões do volume mysql antes do build..."

# Ajusta dono e permissões só para o usuário atual
sudo chown -R $(id -u):$(id -g) ./.docker/mysql/dbdata
sudo chmod -R u+rwX,g-rwX,o-rwX ./.docker/mysql/dbdata

echo "Permissões corrigidas."
