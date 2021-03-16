<?php

        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Force no caching

        header("Content-Type: text/plain");

        $HostPort = $_GET["Port"];
        
        if (!filter_var($HostPort, FILTER_VALIDATE_INT) || ($HostPort > 65535 || $HostPort < 0)) { $HostPort = 53640; }

?>
--[[
        To host your game with this script, paste this in
        the command bar in RB07's Studio:
                dofile("<?php echo 'http://pork.co.nf/host.php?Port=' .  $HostPort . '?' . time(); ?>")
        
        If you can't find the command bar, go up to the top
        menu bar and click View -> Toolbars -> Command Bar.
        
        Generated to host on port <?php echo $HostPort; ?>.
--]]

local function FailMessage(m) game:SetMessage(m) wait(math.huge) end
local function SetMessage(m) game:SetMessage(m) end

local LogChatToOutput = false

if (type(<?php echo $HostPort; ?>) ~= "number") then FailMessage("An invalid port was provided.") end

local NetworkServer = game:GetService("NetworkServer")
NetworkServer:Start(<?php echo $HostPort; ?>, 10)

-- Player functions
local function BindRespawn(player)
        if (player.Character) then
                repeat wait() until player.Character.Humanoid ~= nil
                player.Character.Humanoid.Died:connect(function()
                        wait(5)
                        player:LoadCharacter()
                end)
        end
end

game:GetService("Players").PlayerAdded:connect(function(p)

	print(string.format("%s joined the game.", p.Name))

	local CharApp = game:HttpGet("http://rhodum.xyz/charapp/?uname=" .. p.Name, true)
	-- print(string.format("CharacterAppearance for %s: %s", p.Name, CharApp))
	p.CharacterAppearance = CharApp

	if (LogChatToOutput) then
		p.Chatted:connect(function(msg)
			local ChatMessage = string.format("[%s]: %s", p.Name, msg)
			print(ChatMessage)

			if (msg == "/reset") then
				if (workspace[p.Name]) then
					workspace[p.Name].Humanoid.Health = 0
				end
			end
		end)
	end

	p.Changed:connect(function(propertyName)
		if (propertyName == "Character") then
			BindRespawn(p)
		end
	end)

	p:LoadCharacter()
        
end)

game:service("RunService"):Run()
