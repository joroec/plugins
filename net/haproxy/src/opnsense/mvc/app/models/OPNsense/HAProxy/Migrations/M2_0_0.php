<?php
/**
 *    Copyright (C) 2017 Frank Wall
 *
 *    All rights reserved.
 *
 *    Redistribution and use in source and binary forms, with or without
 *    modification, are permitted provided that the following conditions are met:
 *
 *    1. Redistributions of source code must retain the above copyright notice,
 *       this list of conditions and the following disclaimer.
 *
 *    2. Redistributions in binary form must reproduce the above copyright
 *       notice, this list of conditions and the following disclaimer in the
 *       documentation and/or other materials provided with the distribution.
 *
 *    THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESS OR IMPLIED WARRANTIES,
 *    INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 *    AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *    AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 *    OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 *    SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 *    INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 *    CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 *    ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 *    POSSIBILITY OF SUCH DAMAGE.
 *
 */
namespace OPNsense\HAProxy\Migrations;

use OPNsense\Base\BaseModelMigration;

class M2_0_0 extends BaseModelMigration
{
    public function run($model)
    {
        // Migrate ACLs
        foreach ($model->getNodeByReference('acls.acl')->__items as $acl) {
            switch ((string)$acl->expression) {
                case 'host_starts_with':
                    $acl->expression = 'hdr_beg';
                    $acl->hdr_beg = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'host_ends_with':
                    $acl->expression = 'hdr_end';
                    $acl->hdr_end = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'host_matches':
                    $acl->expression = 'hdr';
                    $acl->hdr = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'host_regex':
                    $acl->expression = 'hdr_reg';
                    $acl->hdr_reg = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'host_contains':
                    $acl->expression = 'hdr_sub';
                    $acl->hdr_sub = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'path_starts_with':
                    echo "DEBUG: migrating : " . (string)$acl->name . "\n";
                    echo "  DEBUG: value: " . (string)$acl->value . "\n";
                    $acl->expression = 'path_beg';
                    $acl->path_beg = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'path_ends_with':
                    $acl->expression = 'path_end';
                    $acl->path_end = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'path_matches':
                    $acl->expression = 'path';
                    $acl->path = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'path_regex':
                    $acl->expression = 'path_reg';
                    $acl->path_reg = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'path_contains':
                    $acl->expression = 'path_dir';
                    $acl->path_dir = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'url_parameter':
                    $acl->expression = 'url_param';
                    $acl->url_param_value = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'ssl_c_verify_code':
                    $acl->ssl_c_verify_code = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'ssl_c_ca_commonname':
                    $acl->ssl_c_ca_commonname = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'source_ip':
                    $acl->expression = 'src';
                    $acl->src = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'backendservercount':
                    $acl->expression = 'nbsrv';
                    $acl->nbsrv = (string)$acl->value;
                    $acl->nbsrv_backend = (string)$acl->queryBackend;
                    $acl->value = NULL;
                    $acl->queryBackend = NULL;
                    break;
                case 'ssl_sni_matches':
                    $acl->expression = 'ssl_sni';
                    $acl->ssl_sni = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'ssl_sni_contains':
                    $acl->expression = 'ssl_sni_sub';
                    $acl->ssl_sni_sub = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'ssl_sni_starts_with':
                    $acl->expression = 'ssl_sni_beg';
                    $acl->ssl_sni_beg = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'ssl_sni_ends_with':
                    $acl->expression = 'ssl_sni_end';
                    $acl->ssl_sni_end = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'ssl_sni_regex':
                    $acl->expression = 'ssl_sni_reg';
                    $acl->ssl_sni_reg = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                case 'custom_acl':
                    $acl->custom_acl = (string)$acl->value;
                    $acl->value = NULL;
                    break;
                default:
                    echo "DEBUG: no ACL migration required: " . (string)$acl->name . "\n";
            }
        }

        // Migrate Actions
        foreach ($model->getNodeByReference('actions.action')->__items as $action) {
            switch ((string)$action->type) {
                case 'use_backend':
                    $action->use_backend = (string)$action->useBackend;
                    $action->useBackend = NULL;
                    break;
                case 'use_server':
                    $action->use_server = (string)$action->useServer;
                    $action->useServer = NULL;
                    break;
                case 'http-request_auth':
                    $action->http_request_auth = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_redirect':
                    $action->http_request_redirect = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_lua':
                    $action->http_request_lua = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_use-service':
                    $action->http_request_use_service = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_add-header':
                    $action->http_request_add_header_name = (string)$action->actionName;
                    $action->http_request_add_header_content = (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_set-header':
                    $action->http_request_set_header_name = (string)$action->actionName;
                    $action->http_request_set_header_content = (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_del-header':
                    $action->http_request_del_header_name = (string)$action->actionName;
                    $action->actionName = NULL;
                    break;
                case 'http-request_replace-header':
                    $action->http_request_replace_header_name = (string)$action->actionName;
                    $action->http_request_replace_header_regex = (string)$action->actionFind . ' ' . (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionFind = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-request_replace-value':
                    $action->http_request_replace_value_name = (string)$action->actionName;
                    $action->http_request_replace_value_regex = (string)$action->actionFind . ' ' . (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionFind = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-response_lua':
                    $action->http_response_lua = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'http-response_add-header':
                    $action->http_response_add_header_name = (string)$action->actionName;
                    $action->http_response_add_header_content = (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-response_set-header':
                    $action->http_response_set_header_name = (string)$action->actionName;
                    $action->http_response_set_header_content = (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-response_del-header':
                    $action->http_response_del_header_name = (string)$action->actionName;
                    $action->actionName = NULL;
                    break;
                case 'http-response_replace-header':
                    $action->http_response_replace_header_name = (string)$action->actionName;
                    $action->http_response_replace_header_regex = (string)$action->actionFind . ' ' . (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionFind = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'http-response_replace-value':
                    $action->http_response_replace_value_name  = (string)$action->actionName;
                    $action->http_response_replace_value_regex = (string)$action->actionFind . ' ' . (string)$action->actionValue;
                    $action->actionName = NULL;
                    $action->actionFind = NULL;
                    $action->actionValue = NULL;
                    break;
                case 'tcp-request_content_lua':
                    $action->tcp_request_content_lua = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'tcp-request_content_use-service':
                    $action->tcp_request_content_use_service = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'tcp-response_content_lua':
                    $action->tcp_response_content_lua = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                case 'custom':
                    $action->custom = (string)$action->actionValue;
                    $action->actionValue = NULL;
                    break;
                default:
                    echo "DEBUG: no Action migration required: " . (string)$action->name . "\n";
            }
        }

        // Migrate Healthchecks
        foreach ($model->getNodeByReference('healthchecks.healthcheck')->__items as $hc) {
            switch ((string)$hc->type) {
                case 'agent':
                    $hc->agent_port = (string)$hc->agentPort;
                    $hc->agentPort = NULL;
                    break;
                case 'mysql':
                    $hc->mysql_user = (string)$hc->dbUser;
                    $hc->dbUser = NULL;
                    break;
                case 'pgsql':
                    $hc->pgsql_user = (string)$hc->dbUser;
                    $hc->dbUser = NULL;
                    break;
                case 'smtp':
                    $hc->smtp_domain = (string)$hc->smtpDomain;
                    $hc->smtpDomain = NULL;
                    break;
                case 'esmtp':
                    $hc->esmtp_domain = (string)$hc->smtpDomain;
                    $hc->smtpDomain = NULL;
                    break;
                default:
                    echo "DEBUG: no Healthcheck migration required: " . (string)$hc->name . "\n";
            }
        }

    }
}
